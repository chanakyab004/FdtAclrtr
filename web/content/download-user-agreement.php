<?php
	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;
	
  	$dompdf = new DOMPDF();
			
	$html ='<html>
	<style>
				body { margin-top:-10px; }
			</style>
	<body>
    <div class="row">
      	<div class="medium-12 columns">
        	<p style="margin-top:2rem;">
            	<strong>SOFTWARE SUBSCRIPTION SERVICE AGREEMENT</strong>
            	<br/> <br/> 
				THIS SOFTWARE SUBSCRIPTION SERVICE AGREEMENT (the “Agreement”) is entered into and effective the date of the last signature below (“Effective Date) by and between Accelerated Development Group, LLC, a Missouri limited liability company located at 523 SW Market Street, Lee\'s Summit, MO 64063 (“ADG”), and the Customer identified on Software Subscription Sign Up Process (“Order Form”).  In this Agreement, “user,” "you" and "your" refer to Customer and "we", us" and "our" refer to ADG.
				<br/> <br/> 
				ADG owns the FOUNDATION ACCELERATOR™ software (“Software”) and provides access and services related to the Software, as further defined below (“Services”), subject to the terms of this Agreement.  It is your responsibility to review this Agreement carefully.  
				<br/> <br/> 
				YOU AGREE THAT THIS AGREEMENT IS ENFORCEABLE LIKE ANY WRITTEN NEGOTIATED AGREEMENT SIGNED BY YOU. ADG IS WILLING TO PROVIDE SERVICES TO YOU ONLY ON THE CONDITION THAT YOU ACCEPT ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT. YOU ACKNOWLEDGE THAT YOU HAVE READ ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT, UNDERSTAND THEM AND AGREE TO BE LEGALLY BOUND BY THEM.  IF YOU DO NOT AGREE TO THE TERMS AND CONDITIONS OF THIS AGREEMENT, DO NOT ACCESS OR USE THE SERVICES.  
				<br/> <br/> 
				<strong>1.	DEFINITIONS</strong>
				<br/> <br/> 
				<strong>“Customer Data”</strong> means all Customer’s information, data and materials provided by Customer to ADG for use in connection with the Services, including but not limited to Customer’s client names and contact information.
				<br/> <br/> 
				<strong>“Custom Services”</strong> means all technical and non-technical services performed or delivered by ADG under this Agreement, including, without limitation, implementation and/or installation services and other professional services, consulting, training and education services, excluding the Services.  Custom Services will be provided on a time and material basis at such times or during such periods, as may be specified in a Statement of Work and mutually agreed to by the parties. 
				<br/> <br/> 
				<strong>“Documentation”</strong> means the user guides, training materials and other documentation ADG provides to Customer in connection with providing the Services and access to the Software. 
				<br/> <br/> 
				<strong>“Software”</strong> means the object code version of ADG’s FOUNDATION ACCELERATOR™ software or any software to which ADG provides Customer use of or access to as part of the Services, including any updates or new versions. 
				<br/> <br/> 
				<strong>“Services”</strong> refer to ADG’s cloud-based software subscription service that provides use of ADG’s proprietary FOUNDATION ACCELERATOR™ customer relationship management Software that is hosted by ADG and/or its third-party service provides and made available to Customer pursuant to the terms and conditions of this Agreement. 
				<br/> <br/> 
				 <strong>“Subscribers”</strong> means each Customer employee designated by Customer to have access to and use of the Services.
				 <br/> <br/> 
				<strong>“Subscription Term”</strong> shall mean that period specified in the Order Form during which Customer will have online access and use of the Software through ADG’s Services. The Subscription Term will automatically renew for successive 12-month periods unless ADG or Customer sends written notice of non-renewal at least 30 days prior to the expiration of the current Subscription Term. 
				<br/> <br/> 
				<strong>2.	SOFTWARE SUBSCRIPTION SERVICES</strong>
				<br/> <br/> 
				During the Subscription Term, Customer will receive a nonexclusive, non-assignable right to access and use the Services solely for Customer’s internal business operations for Subscribers subject to the terms and conditions of this Agreement and for the number Subscribers identified on the Order Form.  Customer understands and acknowledges that this Agreement is a services agreement, not a software license agreement, and ADG will not be delivering copies of the Software to Customer as part of the Services. 
				<br/> <br/> 
				<strong>3.	RESTRICTIONS ON USE OF SERVICES AND SOFTWARE</strong>
				<br/> <br/> 
				Customer shall not, and shall not permit Subscribers or anyone else to: (i) copy or republish the Software or Services, (ii) make the Services available to any person other than authorized Identity Cube users, (iii) use or access the Services to provide service bureau, time-sharing or other computer hosting services to third parties, (iv) modify or create derivative works based upon the Services or Documentation, (v) remove, modify or obscure any copyright, trademark or other proprietary notices contained in the software used to provide the Services or in the Documentation, (vi) reverse engineer, decompile, disassemble, or otherwise attempt to derive the source code of the Software used to provide the Services, except and only to the extent such activity is expressly permitted by applicable law, or (vii) access the Services or use the Documentation in order to build a similar product or competitive products and/or services. Subject to the limited access provided to Customer under this Agreement, ADG exclusively owns all right, title and interest in and to the Software, Services and Documentation, including all modifications, improvements and upgrades. 
				<br/> <br/> 
				<strong>4.	CUSTOMER’S RIGHTS AND RESPONSIBILITIES</strong>
				<br/> <br/> 
				4.1 <u>Assistance.</u> Customer will provide commercially reasonable information and assistance to ADG to enable ADG to deliver the Services, as requested by ADG. Customer acknowledges that ADG’s ability to deliver the Services in the manner provided in this Agreement may depend upon the accuracy and timeliness of such information and assistance. 
				<br/> <br/> 
				4.2 <u>Compliance with Laws and Third-Party Rights.</u> Customer will comply with all applicable regulations and laws in connection with its use of the Services.  Customer understands acknowledges that ADG exercises no control over the Customer Data provided by Customer through Customer’s use of the Services. 
				<br/> <br/> 
				4.3 <u>False Information; Password Protection.</u>  Customer agrees to agree to provide and maintain true, complete and current information to and with ADG. Customer is solely responsible for all activities that occur in connection with any Subscriber’s use of the Services.  Passwords are confidential and Customer agrees not to communicate passwords to any third-party individual or website. Customer will notify ADG immediately of any unauthorized use of Customer’s passwords or any other breach of security that is known or suspected by Customer.  ADG will not be responsible for any unauthorized access to or alteration of Customer’s transmissions of Customer Data sent or received, regardless of whether the Customer Data is actually received by ADG, for Customer’s failure to abide by the terms and conditions of this Agreement. 
				<br/> <br/> 
				4.4 <u>Subscriber Access.</u> Customer shall be solely responsible for the acts and omissions of its Subscribers.  ADG shall not be liable for any loss of data or functionality caused directly or indirectly by Customer’s Subscribers. 
				<br/> <br/> 
				4.5 <u>Customer Data Warranties and Representations.</u> Customer is solely responsible for all Customer Data that Customer uploads and/or transmits through the Services.  Customer represents and warrants for all Customer Data that Customer: (i) has all necessary distribution and publication rights; (ii) if any third party has any right, title or interest in such Customer Data, that Customer has either (a) received permission from such third party to make the Customer Data available through the Services; or (b) secured from the third party a waiver as to all rights necessary in or to the Customer Data; (iii) Customer has fully complied with any third-party licenses; (iv) it does not contain or install any viruses, worms, Trojan horses or any other harmful or destructive code; (v) it is not and does not contain spam, is not machine- or randomly-generated and does not contain unethical or unwanted commercial content designed to drive traffic to third party sites or boost the search engine rankings of third party sites, or to further unlawful acts (such as phishing) or mislead recipients as to the source of the material (such as spoofing); (vi) it is not libelous or defamatory, does not contain threats or incite violence towards individuals or entities, and does not violate the privacy or publicity rights of any third party; (vii) it does not infringe or violate any patent, copyright, trade secret, trademark or other intellectual property right of any third party; and (viii) it does not violate any applicable international, federal, state or local law, rule, legislation, regulation of ordinance. 
				<br/> <br/> 
				4.6 <u>License from Customer.</u>  Customer grants ADG a non-exclusive, worldwide, perpetual, irrevocable, royalty-free, sublicensable (through multiple tiers license) right and license to copy, transmit, distribute, display and prepare derivative works of Customer Data as necessary to provide the Services to Customer and as provided in this Section.  ADG also collects, analyzes and uses Customer Data in the maintenance, administration and improvement of the Services and Software.  ADG also may share Customer Data with technology and business affiliates and partners and/or may use information for research purposes, but ADG will refer only to aggregate data, not specific Customer-identifying information.  For example, ADG may anonymously compile statistical information related to the performance of the Services for purposes of improving Services or Software, provided that such information does not individually identify Customer’s Customer Data or include Customer’s name.  In addition, ADG may combine your Customer Data with Customer Data that ADG collects from other Customers to enhance, improve and personalize the Services and Software or for any other lawful purpose.
				<br/> <br/> 
				4.7 <u>Ownership of Customer Data.</u> Customer retains exclusive ownership of Customer Data. ADG or its licensors retain all ownership and intellectual property rights to the Services, Software, Documentation and any programs or other materials developed under this Agreement. 
				<br/> <br/> 
				4.8 <u>Customer Input and Feedback.</u>  Customer agrees that ADG shall have a royalty-free, worldwide, irrevocable, perpetual license to use and incorporate into the Services and Software any suggestions, enhancement requests, recommendations or other input or feedback provided by Customer, including Subscribers.
				<br/> <br/> 
				<strong>5.	MAINTENANCE</strong>
				<br/> <br/> 
				ADG will use reasonable efforts consistent with prevailing industry standards to maintain the Services in a manner that minimizes errors and interruptions in the Services.  However, Customer understands and agrees that the Services may be temporarily unavailable for scheduled maintenance or for unscheduled emergency maintenance, either by Company or by third-party providers, or because of other causes beyond Company’s reasonable control, but Company shall use reasonable efforts to provide advance notice in writing or by e-mail of any scheduled service disruption.  
				<br/> <br/> 
				<strong>6.	INTELLECTUAL PROPERTY OWNERSHIP</strong>
				<br/> <br/> 
				The Software is protected by United States copyright law and international treaty provisions.  Title to the Software and all associated intellectual property rights are owned and shall be retained exclusively by ADG, its affiliates and/or its licensors as applicable. Through your use of the Services and Software, you acquire no ownership interest in the Software or any derivative work of the Software.  No right, title or interest in or to the FOUNDATION ACCELERATOR™ mark or any other trademark, service mark, logo or trade name of ADG or its licensors is granted to you under this Agreement.  You acknowledge that the Software, any enhancements, corrections, upgrades or modifications to the Software (regardless of whether made by ADG, its affiliates, its licensors, you or a third party) and all copyrights, patents, trade secrets, trademarks and other intellectual property rights protecting or pertaining to any aspect of the Software (or any enhancements, corrections, upgrades or modifications) are and shall remain the exclusive property of ADG, its affiliates and/or its licensors as applicable.
				<br/> <br/> 
				<strong>7.	ORDERS AND PAYMENT</strong>
				<br/> <br/> 
				7.1 <u>Orders.</u>  ADG will provide Services to Customer as specified on the Order Form.  All Services provided by ADG to Customer shall be governed exclusively by this Agreement. In the event of a conflict between the terms of this Agreement and a Statement of Work, the terms of the Schedule shall take precedence. 
				<br/> <br/> 
				7.2 <u>Invoicing and Payment.</u>  ADG will charge Customer’s credit card on file with ADG for the Subscription Fees and in accordance with the terms specified on the Order Form.  Except as expressly provided otherwise, all Subscription Fees and any other fees paid by Customer to ADG are non-refundable.  All Subscription Fees and any other fees by ADG are stated in United States Dollars and must be paid by Customer to ADG in United States Dollars.   
				<br/> <br/> 
				7.3 <u>Taxes.</u>  Customer shall be responsible for payment of all sales and use taxes, value added taxes (VAT) and similar charges associated with Customer’s purchase and use of the Services.  
				<br/> <br/> 
				<strong>8.	ADG FORMS AND AUTOMATED COMMUNICATIONS</strong>
				As part of the Services, ADG creates and transmits certain automated communications to Customer’s clients that include Customer Data provided by Customer to ADG (“Client Communications”).  Customer understands and agrees that Customer is solely responsible the Customer Data contained in the Client Communications that ADG transmits on Customer’s behalf.  In addition, ADG provides certain forms to Customer such as forms for bids and purchase orders for Customer’s services (“Forms”).  ADG provides Forms to Customer for Customer’s internal use and as a convenience only.  Further, ADG provides Forms on an “as is” basis and does not represent or warrant that the Forms are valid or legally enforceable documents.  ADG does not provide legal advice and ADG encourages Customer to seek advice from an attorney regarding the enforceability of any Form in Customer’s jurisdiction.  
				<br/> <br/> 
				<strong>9.	TERM AND TERMINATION</strong>
				<br/> <br/> 
				9.1 <u>Subscription Term.</u> The Subscription Term shall begin on the Effective Date and shall continue through the date specified on the Order form unless terminated earlier in accordance with the terms of this Agreement. 
				<br/> <br/> 
				9.2 <u>Termination.</u> Either party may terminate this Agreement immediately upon a material breach by the other party that has not been cured within thirty (30) days after receipt of notice of such breach. 
				<br/> <br/> 
				9.3 <u>Suspension for Customer’s Non-Payment.</u> ADG reserves the right to suspend Customer’s access to Services if Customer fails to timely pay any amounts due to ADG under this Agreement failure and such failure continues for fifteen (15) days.  Suspension of the Services shall not release Customer of its payment obligations under this Agreement. Customer agrees that ADG shall not be liable to Customer or to any third party for any liabilities, claims or expenses arising from or relating to suspension of the Services resulting from Customer’s non-payment.  
				<br/> <br/> 
				9.4 <u>Effect of Termination. </u>
				<br/> <br/> 
				(a) Upon termination of this Agreement or expiration of the Subscription Term, ADG shall immediately cease providing the Services and all usage rights granted under this Agreement shall terminate. 
				<br/> <br/> 
				(b) If ADG terminates this Agreement as a result of Customer’s breach, then Customer shall immediately pay to ADG all amounts then due under this Agreement and to become due during the remaining Subscription Term of this Agreement.  
				<br/> <br/> 
				(c) Upon termination of this Agreement and upon subsequent written request by the disclosing party, the receiving party of tangible Confidential Information shall immediately return such information or destroy such information and provide written certification of such destruction, provided that the receiving party may permit its legal counsel to retain one archival copy of such information in the event of a subsequent dispute between the parties. 
				<br/> <br/> 
				<strong>10.	WARRANTIES</strong>
				<br/> <br/> 
				10.1 <u>Warranty.</u> ADG represents and warrants that it will provide the Services in a professional manner consistent with general industry standards and that the Services will perform substantially in accordance with the Documentation. For any beach of a warranty, Customer’s exclusive remedy shall be as provided in Section 9, Term and Termination. 
				<br/> <br/> 
				10.2 ADG WARRANTS THAT IT WILL PROVIDE THE SERVICES IN ACCORDANCE WITH THE DOCUMENTATION. ADG DOES NOT GUARANTEE THAT THE SERVICES OR CUSTOMER’S ACCESS TO THE SOFTWARE WILL BE PERFORMED ERROR-FREE OR UNINTERRUPTED, OR THAT ADG WILL CORRECT ALL ERRORS. CUSTOMER ACKNOWLEDGES THAT ADG DOES NOT CONTROL THE TRANSFER OF CUSTOMER DATA AND/OR OTHER DATA OVER COMMUNICATIONS FACILITIES, INCLUDING THE INTERNET, AND THAT THE  SERVICES MAY BE SUBJECT TO LIMITATIONS, DELAYS, AND OTHER PROBLEMS INHERENT IN THE USE OF SUCH COMMUNICATIONS FACILITIES. THIS SECTION SETS FORTH THE SOLE AND EXCLUSIVE WARRANTY GIVEN BY ADG (EXPRESS OR IMPLIED) WITH RESPECT TO THE SUBJECT MATTER OF THIS AGREEMENT. NEITHER ADG NOR ANY OF ITS LICENSORS OR OTHER SUPPLIERS WARRANT OR GUARANTEE THAT THE SERVICES OR ACCESS THE SOFTWARE WILL BE UNINTERRUPTED, VIRUS-FREE OR ERROR-FREE, NOR SHALL ADG OR ANY OF ITS LICENSORS OR SUBCONTRACTORS BE LIABLE FOR UNAUTHORIZED ALTERATION, THEFT OR DESTRUCTION OF CUSTOMER DATA. 
				<br/> <br/> 
				SOME STATES MAY NOT ALLOW EXCLUSIONS OR LIMITATIONS OF IMPLIED WARRANTIES SO THE ABOVE LIMITATIONS MAY NOT APPLY TO YOU AND, IN SUCH CASE, ANY IMPLIED WARRANTIES ARE LIMITED IN DURATION TO SIXTY (60) DAYS FROM THE EFFECTIVE DATE SOME STATES DO NOT ALLOW LIMITATIONS ON HOW LONG AN IMPLIED WARRANTY LASTS, SO THE ABOVE LIMITATION MAY NOT APPLY TO YOU.
				<br/> <br/> 
				YOU ACKNOWLEDGE THAT ADG AND ITS RESPECTIVE SUBCONTRACTORS, LICENSORS, AFFILIATES AND SUBSIDIARIES DO NOT PRACTICE LAW NOR ARE THEY PROVIDING OR RENDERING ANY SUCH LEGAL OR OTHER PROFESSIONAL SERVICES TO YOU WITH REGARD TO THE SERVICES OR SOFTWARE.  YOU ACKNOWLEDGE AND AGREE THAT THE YOUR USE OF THE SERVICES AND SOFTWARE ARE NOT SUBSTITUTES FOR THE ADVICE OF AN ATTORNEY.  YOU FURTHER ACKNOWLEDGE AND AGREE THAT LAWS VARY FROM STATE TO STATE AND CHANGE OVER TIME AND THAT THE FINAL DOCUMENTS, FORMS AND LETTERS SHOULD BE REVIEWED BY AN ATTORNEY BEFORE USE.  
				<br/> <br/> 
				<strong>11.	LIMITATIONS OF LIABILITY</strong>
				<br/> <br/> 
				NEITHER PARTY (NOR ANY LICENSOR OR OTHER SUPPLIER OF ADG) SHALL BE LIABLE FOR INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES, INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOST BUSINESS, PROFITS, DATA OR USE OF ANY SERVICE, INCURRED BY EITHER PARTY OR ANY THIRD PARTY IN CONNECTION WITH THIS AGREEMENT, REGARDLESS OF THE NATURE OF THE CLAIM (INCLUDING NEGLIGENCE), EVEN IF FORESEEABLE OR THE OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. NEITHER PARTY’S AGGREGATE LIABILITY FOR DAMAGES UNDER THIS AGREEMENT, REGARDLESS OF THE NATURE OF THE CLAIM (INCLUDING NEGLIGENCE), SHALL EXCEED THE FEES PAID OR PAYABLE BY CUSTOMER UNDER THIS AGREEMENT DURING THE 12 MONTHS PRECEDING THE DATE THE CLAIM AROSE. The foregoing limitations shall not apply to the parties’ obligations or breach of Sections 12 or 13. 
				<br/> <br/> 
				<strong>12.	INDEMNIFICATION</strong>
				<br/> <br/> 
				12.1 <u>Indemnification by ADG.</u>  ADG agrees to defend and hold harmless Customer and its successors, assigns, officers, directors, representatives, employees and agents from and against any claim, suit, loss, liability, penalty or damages, costs and expenses (including reasonable attorneys’ fees and expenses), arising out of ADG’s breach of this Agreement at ADG’s expense and ADG shall pay all losses, damages and expenses (including reasonable attorneys’ fees) finally awarded against such parties or agreed to in a written settlement agreement signed by ADG, to the extent arising from the claim.  Notwithstanding the foregoing, ADG shall have no liability for any claim based on (a) the Customer Data, (b) modification of the Services not authorized by ADG, or (c) use of the Services other than in accordance with the Documentation and this Agreement. ADG may, at its sole option and expense, procure for Customer the right to continue use of the Services, modify the Services in a manner that does not materially impair the functionality, or terminate the Subscription Term and repay to Customer any amount paid by Customer with respect to the Subscription Term following the termination date. 
				<br/> <br/> 
				12.2 <u>Indemnification by Customer.</u>  Customer agrees to defend and hold harmless ADG and its successors, assigns, officers, directors, representatives, employees and agents from and against any claim, suit, loss, liability, penalty or damages, costs and expenses (including reasonable attorneys’ fees and expenses), arising out of Customer’s breach of this Agreement at Customer’s expense and Customer shall pay all losses, damages and expenses (including reasonable attorneys’ fees) finally awarded against such parties or agreed to in a written settlement agreement signed by Customer, to the extent arising from the claim.  
				<br/> <br/> 
				12.3 <u>Indemnification Conditions.</u> A party seeking indemnification under this section shall (a) promptly notify the other party of the claim, (b) give the other party sole control of the defense and settlement of the claim, and (c) provide, at the other party’s expense for out-of-pocket expenses, the assistance, information and authority reasonably requested by the other party in the defense and settlement of the claim. 
				<br/> <br/> 
				<strong>13.	CONFIDENTIALITY</strong>
				<br/> <br/> 
				13.1 <u>“Confidential Information”</u> means any information disclosed by a party to the other party, directly or indirectly, which, (a) if in written, graphic, machine-readable or other tangible form, is marked as “confidential” or “proprietary,” (b) if disclosed orally or by demonstration, is identified at the time of initial disclosure as confidential and is confirmed in writing to the receiving party to be “confidential” or “proprietary” within 30 days of such disclosure, (c) is specifically deemed to be confidential by the terms of this Agreement; or (d) reasonably appears to be confidential or proprietary because of the circumstances of disclosure and the nature of the information itself.  Subject to Section 4.6, Customer Data is deemed Confidential Information of Customer.  ADG’s Software and Documentation are deemed Confidential Information of ADG. 
				<br/> <br/> 
				13.2 <u>Confidentiality.</u>  During the term of this Agreement and for 5 years thereafter (and perpetually in the case of software), each party shall treat as confidential all Confidential Information of the other party, shall not use such Confidential Information except to exercise its rights and perform its obligations under this Agreement, and shall not disclose such Confidential Information to any third party. Without limiting the foregoing, each party shall use at least the same degree of care, but not less than a reasonable degree of care, it uses to prevent the disclosure of its own confidential information to prevent the disclosure of Confidential Information of the other party. Each party shall promptly notify the other party of any actual or suspected misuse or unauthorized disclosure of the other party’s Confidential Information. Each party may disclose Confidential Information of the other party on a need-to-know basis to its contractors who are subject to confidentiality agreements requiring them to maintain such information in confidence and use it only to facilitate the performance of their services on behalf of the receiving party. 
				<br/> <br/> 
				13.3 <u>Exceptions.</u> Confidential Information excludes information that: (a) is known publicly at the time of the disclosure or becomes known publicly after disclosure through no fault of the receiving party, (b) is known to the receiving party, without restriction, at the time of disclosure or becomes known to the receiving party, without restriction, from a source other than the disclosing party not bound by confidentiality obligations to the disclosing party; or (c) is independently developed by the receiving party without use of the Confidential Information as demonstrated by the written records of the receiving party. The receiving party may disclose Confidential Information of the other party to the extent such disclosure is required by law or order of a court or other governmental authority, provided that the receiving party shall use reasonable efforts to promptly notify the other party prior to such disclosure to enable the disclosing party to seek a protective order or otherwise prevent or restrict such disclosure. Each party may disclose the existence of this Agreement and the relationship of the parties, but agrees that the specific terms of this Agreement will be treated as Confidential Information; provided, however, that each party may disclose the terms of this Agreement to those with a need to know and under a duty of confidentiality such as accountants, lawyers, bankers and investors. 
				<br/> <br/> 
				<strong>14.	GENERAL PROVISIONS</strong>
				<br/> <br/> 
				14.1 <u>Non-Exclusive Service.</u> Customer acknowledges that Services is provided on a non-exclusive basis. Nothing shall be deemed to prevent or restrict ADG’s ability to provide the Services or other technology to other parties. 
				<br/> <br/> 
				14.2 <u>Security.</u>  ADG implements physical, electronic and managerial procedures to safeguard and secure Customer Data.   Customer also needs to work to protect against unauthorized access to its computers and other electronic devices uses to access the Services for security purposes.  ADG follows generally accepted industry standards to protect Customer Data once ADG or its contractors receive it.   Customer understands and agrees that no method of transmission over the Internet or method of electronic storage is 100% secure. Therefore, while ADG strives to use commercially acceptable means to protect Customer Data, ADG cannot guarantee its absolute security.  Under no circumstances will ADG be responsible or liable for any loss or damages, pecuniary or otherwise, caused by a third party’s unauthorized access to or use of your Customer Data. 
				<br/> <br/> 
				14.3 <u>Assignment.</u> Neither party may assign this Agreement or any right under this Agreement, without the consent of the other party, which consent shall not be unreasonably withheld or delayed except that either party may assign this Agreement to a purchaser of all or substantially all of the business of such party to which this Agreement relates. This Agreement shall be binding upon and inure to the benefit of the parties’ successors and permitted assigns.  ADG may use subcontractors in performing its duties under this Agreement. 
				<br/> <br/> 
				14.4 <u>Notices.</u>  Except as otherwise permitted in this Agreement, notices under this Agreement shall be in writing and shall be deemed to have been given (a) five (5) business days after mailing if sent by registered or certified U.S. mail, (b) when transmitted if sent by facsimile, provided that a copy of the notice is promptly sent by another means specified in this section; or (c) when delivered if delivered personally or sent by express courier service.  All notices shall be sent to the other party at the address set forth on the cover page of this Agreement. 
				<br/> <br/> 
				14.5 <u>Waiver.</u>  No waiver shall be effective unless it is in writing and signed by the waiving party. The waiver by either party of any breach of this Agreement shall not constitute a waiver of any other or subsequent breach. 
				<br/> <br/> 
				14.6 <u>Severability.</u> If any term of this Agreement is held to be invalid or unenforceable, that term shall be reformed to achieve as nearly as possible the same effect as the original term, and the remainder of this Agreement shall remain in full force. 
				<br/> <br/> 
				14.7 <u>Entire Agreement.</u> This Agreement contains the entire agreement of the parties and supersedes all previous oral and written communications by the parties, concerning the subject matter of this Agreement.  This Agreement may be amended solely in a writing signed by both parties.  
				<br/> <br/> 
				14.8 <u>Survival.</u> Sections this Agreement shall survive the expiration or termination of this Agreement for any reason and specifically Sections 12 and 13. 
				<br/> <br/> 
				14.9 <u>No Third Party Beneficiaries.</u> This Agreement is an agreement between the parties, and confers no rights upon either party’s employees, agents, contractors, partners of customers or upon any other person or entity. 
				<br/> <br/> 
				14.10 <u>Independent Contractor.</u> The parties have the status of independent contractors and nothing in this Agreement nor the conduct of the parties will be deemed to place the parties in any other relationship.  Except as provided in this Agreement, neither party shall be responsible for the acts or omissions of the other party or the other party’s personnel. 
				<br/> <br/> 
				14.11 <u>Governing Law and Venue.</u> This Agreement shall be governed by the laws of the State of Missouri excluding its conflict of law principles.  Any claim relating to this Agreement shall be governed by the substantive laws of the State of Missouri, without regard to its conflict of law provisions, and Customer agrees that jurisdiction and venue in any legal proceeding arising out of or relating to any of the foregoing shall be exclusive in the state court located in Jackson County, Missouri or the United States District Court for the Western District of Missouri located in Kansas City, Missouri.  Customer agrees to the exclusive jurisdiction of the federal and state courts located in the State of Missouri, and waive any jurisdictional, venue, or inconvenient forum objections to such courts.
				<br/> <br/> 
				14.12 <u>Dispute Resolution.</u>  Except with respect to intellectual property rights, if a dispute arises between the parties relating to this Agreement, the parties agree to hold a meeting (by phone or in person, as the circumstances allow) within ten (10) days of written request by either party, attended by individuals with decision-making authority, regarding the dispute, to attempt in good faith to negotiate a resolution of the dispute.  If, within 30 days after such meeting, the parties have not resolved the dispute, either party may protect its interests by any lawful means available to it. 
				<br/> <br/> 
				14.13 <u>Signatures.</u> This Agreement may be executed in several counterparts, each of which shall be an original, but all of which together shall constitute one and the same Agreement.
          	</p>
      	</div>
   	</div>
   	</body>
</html>';
	
	$dompdf->load_html($html);
	$dompdf->render();
    $dompdf->stream('Foundation-Accelerator-User-Agreement');
    ?>